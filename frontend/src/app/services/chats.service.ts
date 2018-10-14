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

  getMessages(chatId: string, limit: number = 10, lastMessageDate: string = '') {
    let url = `${environment.api_url}/chats/${chatId}/relationships/messages?limit=${limit}`;
    if (lastMessageDate) {
      url += `&last_message_date=${lastMessageDate}`;
    }
    return this.http.get<any>(url);
  }

  sendMessage(chatId: string, text: string) {
    return this.http.post<any>(`${environment.api_url}/chats/${chatId}/relationships/messages`, {text});
  }
}
