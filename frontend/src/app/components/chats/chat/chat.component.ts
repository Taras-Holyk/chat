import {Component, OnDestroy, OnInit} from '@angular/core';
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
        this.getChat(params['user']);
      });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  getChat(userId: string) {
    this.chatsService.getChat(userId)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.chat = result.data;
      });
  }
}
