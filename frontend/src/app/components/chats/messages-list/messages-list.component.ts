import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {Message} from '../../../models/message';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';
import {BroadcastService} from '../../../services/broadcast.service';
import {LocalStorageService} from '../../../services/local-storage.service';

@Component({
  selector: 'app-messages-list',
  templateUrl: './messages-list.component.html',
  styleUrls: ['./messages-list.component.scss']
})
export class MessagesListComponent implements OnInit, OnDestroy {
  messages: Message[];
  @Input() chat;
  alive$ = true;

  constructor(private chatsService: ChatsService,
              private broadcastService: BroadcastService,
              private localStorageService: LocalStorageService) { }

  ngOnInit() {
    if (typeof window['Echo'] !== 'undefined') {
      window['Echo'].join(`chat.${this.chat._id}`)
        .listen('.message.created', (result) => {
          if (result.message.user.id !== this.localStorageService.get('authUser').id) {
            this.add(result.message);
          }
        });
    }

    this.broadcastService.subscribe('message-created', result => {
      this.add(result);
    });

    this.chatsService.getMessages(this.chat._id)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.messages = result.data.reverse();
      });
  }

  add(message: Message) {
    this.messages.push(message);
  }

  ngOnDestroy() {
    this.alive$ = false;
  }
}
