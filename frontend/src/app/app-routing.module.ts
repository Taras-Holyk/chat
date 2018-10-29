import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {RouterModule, Routes} from '@angular/router';
import {AuthGuard} from './auth.guard';
import {LoginComponent} from './components/login/login.component';
import {RegistrationComponent} from './components/registration/registration.component';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'chats',
    pathMatch: 'full'
  },
  {
    path: 'users',
    loadChildren: './components/users/users.module#UsersModule',
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'chats',
    loadChildren: './components/chats/chats.module#ChatsModule',
    canActivate: [
      AuthGuard
    ]
  },
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'register',
    component: RegistrationComponent
  }
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(routes),
  ],
  exports: [RouterModule],
  declarations: []
})
export class AppRoutingModule { }
