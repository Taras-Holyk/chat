import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import { environment} from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  login(email: string, password: string) {
    return this.http.post(`${environment.api_url}/login`, {email, password});
  }
}