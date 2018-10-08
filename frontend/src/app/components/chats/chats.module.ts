import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatsRoutingModule } from './chats-routing.module';
import { ChatComponent } from './chat/chat.component';
import { MessagesListComponent } from './messages-list/messages-list.component';
import { MessageFormComponent } from './message-form/message-form.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

@NgModule({
  imports: [
    CommonModule,
    ChatsRoutingModule,
    FormsModule,
    ReactiveFormsModule
  ],
  declarations: [ChatComponent, MessagesListComponent, MessageFormComponent]
})
export class ChatsModule { }
