import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  constructor(private http: HttpClient) { }

  login(email: string, password: string) {
    return this.http.post<any>(`${environment.api_url}/login`, {email, password});
  }

  register(data: any) {
    return this.http.post<any>(`${environment.api_url}/register`, data);
  }

  logout() {
    return this.http.post<any>(`${environment.api_url}/logout`, {});
  }

  getUsersList(page?: number, limit?: number, search?: string) {
    let url = '';
    if (page) {
      url = `${url}page=${page}`;
    }
    if (limit) {
      url = `${url}&limit=${limit}`;
    }
    if (search) {
      url = `${url}&search=${search}`;
    }
    return this.http.get<any>(`${environment.api_url}/users?${url}`);
  }

  getUser(id: string) {
    return this.http.get<any>(`${environment.api_url}/users/${id}`);
  }
}
