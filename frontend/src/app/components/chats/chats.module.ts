import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatsRoutingModule } from './chats-routing.module';
import { ChatComponent } from './chat/chat.component';
import { MessagesListComponent } from './messages-list/messages-list.component';
import { MessageFormComponent } from './message-form/message-form.component';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import { MessageComponent } from './message/message.component';
import { ChatsListComponent } from './chats-list/chats-list.component';
import { ChatsListItemComponent } from './chats-list-item/chats-list-item.component';

@NgModule({
  imports: [
    CommonModule,
    ChatsRoutingModule,
    FormsModule,
    ReactiveFormsModule
  ],
  declarations: [ChatComponent, MessagesListComponent, MessageFormComponent, MessageComponent, ChatsListComponent, ChatsListItemComponent]
})
export class ChatsModule { }
