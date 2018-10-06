import {Component, OnDestroy, OnInit} from '@angular/core';
import {environment} from '../environments/environment';
import * as socketIo from 'socket.io-client';
import * as Echo from 'laravel-echo';
import {LocalStorageService} from './services/local-storage.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy {
  private socket;
  title = 'Chat';

  constructor(private localStorageService: LocalStorageService) {}

  ngOnInit() {
    if (!this.socket) {
      this.socket = socketIo(environment.sockets_url);
    }

    if (!window['io']) {
      window['io'] = socketIo;
    }

    if (!window['Echo']) {
      window['Echo'] = new Echo({
        broadcaster: 'socket.io',
        host: environment.sockets_url,
        auth: { headers: { 'Authorization': 'Bearer ' + this.localStorageService.get('userAuthToken') } }
      });
    }
  }

  ngOnDestroy() {
    if (!!this.socket) {
      this.socket.disconnect();
    }

    window['io'] = undefined;
    window['Echo'] = undefined;
  }
}
