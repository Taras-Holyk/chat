import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import { Subscription } from 'rxjs';
import { filter, map } from 'rxjs/operators';

interface Action {
  type: string;
  payload?: any;
}

type ActionCallback = (payload: any) => void;

@Injectable({
  providedIn: 'root',
})
export class BroadcastService {
  private handler = new Subject<Action>();

  broadcast(type: string, payload?: any) {
    this.handler.next({ type, payload });
  }

  subscribe(type: string, callback: ActionCallback): Subscription {
    return this.handler
      .pipe(
        filter(message => message.type === type),
        map(message => message.payload)
      )
      .subscribe(callback);
  }
}
