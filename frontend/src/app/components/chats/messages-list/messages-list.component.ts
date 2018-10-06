import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {Message} from '../../../models/message';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';

@Component({
  selector: 'app-messages-list',
  templateUrl: './messages-list.component.html',
  styleUrls: ['./messages-list.component.scss']
})
export class MessagesListComponent implements OnInit, OnDestroy {
  messages: Message[];
  @Input() chat;
  alive$ = true;

  constructor(private chatsService: ChatsService) { }

  ngOnInit() {
    this.chatsService.getMessages(this.chat._id)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.messages = result.data;
      });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }
}
