import {Component, ElementRef, OnDestroy, OnInit, ViewChild} from '@angular/core';
import {takeWhile} from 'rxjs/operators';
import {ActivatedRoute} from '@angular/router';
import {ChatsService} from '../../../services/chats.service';
import {Chat} from '../../../models/chat';

@Component({
  selector: 'app-chat',
  templateUrl: './chat.component.html',
  styleUrls: ['./chat.component.scss']
})
export class ChatComponent implements OnInit, OnDestroy {
  chat: Chat;
  alive$ = true;

  constructor(private activatedRoute: ActivatedRoute,
              private chatsService: ChatsService) { }

  ngOnInit() {
    this.activatedRoute.params
      .pipe(takeWhile(() => this.alive$))
      .subscribe(params => {
        this.getChat(params['chat']);
      });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  getChat(chatId: string) {
    this.chatsService.getChat(chatId)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.chat = result.data;
      });
  }
}
