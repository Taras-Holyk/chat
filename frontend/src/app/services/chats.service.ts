import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ChatsService {

  constructor(private http: HttpClient) { }

  getChat(userId: string) {
    return this.http.get<any>(`${environment.api_url}/chats/${userId}`);
  }
}
