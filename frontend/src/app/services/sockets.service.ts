import { Injectable } from '@angular/core';
import * as socketIo from 'socket.io-client';
import * as Echo from 'laravel-echo';
import {LocalStorageService} from './local-storage.service';
import {environment} from '../../environments/environment';
import {Observable} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class SocketsService {
  private socket;
  constructor(private localStorageService: LocalStorageService) { }

  initSockets() {
    if (!this.socket) {
      this.socket = socketIo(environment.sockets_url);
    }

    if (!window['io']) {
      window['io'] = socketIo;
    }

    if (!window['Echo'] && this.localStorageService.get('userAuthToken')) {
      window['Echo'] = new Echo({
        broadcaster: 'socket.io',
        host: environment.sockets_url,
        auth: { headers: {'Authorization': 'Bearer ' + this.localStorageService.get('userAuthToken'),}}
      });
    }
  }

  destroySockets() {
    if (!!this.socket) {
      this.socket.disconnect();
    }

    window['io'] = undefined;
    window['Echo'] = undefined;
  }

  listenChannelEvent(channelName: string, event: string): Observable<any> {
    if (typeof window['Echo'] !== 'undefined') {
      return window['Echo'].join(channelName)
        .joining(() => {
          console.log('joining');
        })
        .listen(event, (message) => {
          console.log(message);
        });
    }
  }

  leaveChannel(channelName: string) {
    if (!window['Echo']) {
      return;
    }
    window['Echo'].leave(channelName);
  }
}
