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
  lastMessageDate: string;
  blockRequest: boolean;

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

    this.getMessages();
  }

  add(message: Message) {
    this.messages.push(message);
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  onScrollMessages(event) {
    const offset = event.target.scrollTop;
    if (offset <= 50 && !this.blockRequest) {
      this.blockRequest = true;
      this.chatsService.getMessages(this.chat._id, 10, this.lastMessageDate || '')
        .pipe(takeWhile(() => this.alive$))
        .subscribe(result => {
          const messages = result.data.reverse();
          this.messages = [...messages, ...this.messages];

          const lastMessage = messages[0];
          if (lastMessage) {
            this.lastMessageDate = lastMessage.created_at;
          }
          this.blockRequest = false;
        });
    }
  }

  getMessages() {
    this.chatsService.getMessages(this.chat._id, 10, this.lastMessageDate || '')
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.messages = result.data.reverse();

        const lastMessage = this.messages[0];
        if (lastMessage) {
          this.lastMessageDate = lastMessage.created_at;
        }

        const element = document.getElementById('messages-list-container');
        setTimeout(() => element.scrollTop = element.scrollHeight, 100);
      });
  }
}
