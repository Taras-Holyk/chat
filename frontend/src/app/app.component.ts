import {Component, OnDestroy, OnInit} from '@angular/core';
import {SocketsService} from './services/sockets.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy {
  title = 'Chat';

  constructor(private socketsService: SocketsService) {}

  ngOnInit() {
    this.socketsService.initSockets();
  }

  ngOnDestroy() {
    this.socketsService.destroySockets();
  }
}
