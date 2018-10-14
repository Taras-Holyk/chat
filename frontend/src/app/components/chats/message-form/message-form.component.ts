import {Component, EventEmitter, Input, OnDestroy, OnInit, Output} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';
import {SocketsService} from '../../../services/sockets.service';
import {BroadcastService} from '../../../services/broadcast.service';

@Component({
  selector: 'app-message-form',
  templateUrl: './message-form.component.html',
  styleUrls: ['./message-form.component.scss']
})
export class MessageFormComponent implements OnInit, OnDestroy {
  @Input() chat;
  messageForm: FormGroup;
  alive$ = true;
  @Output() addEvent = new EventEmitter();
  constructor(private formBuilder: FormBuilder,
              private chatsService: ChatsService,
              private socketsService: SocketsService,
              private broadcastService: BroadcastService) { }

  ngOnInit() {
    this.messageForm = this.formBuilder.group({
      'text': ['', [Validators.required]]
    });
  }

  ngOnDestroy() {
    this.alive$ = false;

    this.socketsService.leaveChannel(`chat.${this.chat.id}`);
  }

  send() {
    this.chatsService.sendMessage(this.chat.id, this.messageForm.get('text').value)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.messageForm.reset();
        this.broadcastService.broadcast('message-created', result.data);
      });
  }
}
