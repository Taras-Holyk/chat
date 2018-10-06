import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatsRoutingModule } from './chats-routing.module';
import { ChatComponent } from './chat/chat.component';
import { MessagesListComponent } from './messages-list/messages-list.component';

@NgModule({
  imports: [
    CommonModule,
    ChatsRoutingModule
  ],
  declarations: [ChatComponent, MessagesListComponent]
})
export class ChatsModule { }
