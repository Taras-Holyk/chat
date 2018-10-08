import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';
import {SocketsService} from '../../../services/sockets.service';

@Component({
  selector: 'app-message-form',
  templateUrl: './message-form.component.html',
  styleUrls: ['./message-form.component.scss']
})
export class MessageFormComponent implements OnInit, OnDestroy {
  @Input() chat;
  messageForm: FormGroup;
  alive$ = true;
  constructor(private formBuilder: FormBuilder,
              private chatsService: ChatsService,
              private socketsService: SocketsService) { }

  ngOnInit() {
    this.messageForm = this.formBuilder.group({
      'text': ['', [Validators.required]]
    });

    this.socketsService.listenChannelEvent(`chat.${this.chat._id}`, '.message.created');
  }

  ngOnDestroy() {
    this.alive$ = false;

    this.socketsService.leaveChannel(`chat.${this.chat._id}`);
  }

  send() {
    this.chatsService.sendMessage(this.chat._id, this.messageForm.get('text').value)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        console.log(result);
      });
  }
}
