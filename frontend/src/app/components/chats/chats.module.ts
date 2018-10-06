import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChatsRoutingModule } from './chats-routing.module';
import { ChatComponent } from './chat/chat.component';

@NgModule({
  imports: [
    CommonModule,
    ChatsRoutingModule
  ],
  declarations: [ChatComponent]
})
export class ChatsModule { }
