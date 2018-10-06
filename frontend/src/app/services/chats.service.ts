import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ChatsService {

  constructor(private http: HttpClient) { }

  createChat(userId: string) {
    return this.http.post<any>(`${environment.api_url}/chats/${userId}`, {});
  }

  getChat(chatId: string) {
    return this.http.get<any>(`${environment.api_url}/chats/${chatId}`);
  }

  getMessages(chatId: string) {
    return this.http.get<any>(`${environment.api_url}/chats/${chatId}/relationships/messages`);
  }
}
