import {Component, OnDestroy, OnInit} from '@angular/core';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';
import {Chat} from '../../../models/chat';
import {LocalStorageService} from '../../../services/local-storage.service';

@Component({
  selector: 'app-chats-list',
  templateUrl: './chats-list.component.html',
  styleUrls: ['./chats-list.component.scss']
})
export class ChatsListComponent implements OnInit, OnDestroy {
  chats: Chat[] = [];
  alive$ = true;
  limit = 10;
  page = 1;
  isEnabledShowMore = false;
  constructor(private chatsService: ChatsService,
              private localStorageService: LocalStorageService) { }

  ngOnInit() {
    if (typeof window['Echo'] !== 'undefined') {
      window['Echo'].join(`chats.${this.localStorageService.get('authUser').id}`)
        .listen('.chat.updated', (result) => {
          this.chats.find(item => result.chat.id === item.id).last_message = result.chat.last_message;
        });
    }

    this.getMessages();
  }

  ngOnDestroy() {
    this.alive$ = false;
  }
  getMessages() {
    this.chatsService.getChats(this.limit, this.page)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.chats = [...this.chats, ...result.data];

        if (this.chats.length >= result.meta.total) {
          this.isEnabledShowMore = false;
        } else {
          this.isEnabledShowMore = true;
        }
      });
  }
  showMore() {
    this.page++;
    this.getMessages();
  }
}
