import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {RouterModule, Routes} from '@angular/router';
import {ChatComponent} from './chat/chat.component';
import {ChatsListComponent} from './chats-list/chats-list.component';

const routes: Routes = [
  {
    path: '',
    component: ChatsListComponent
  },
  {
    path: ':chat',
    component: ChatComponent
  },
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forChild(routes)
  ],
  exports: [RouterModule],
  declarations: []
})
export class ChatsRoutingModule { }
