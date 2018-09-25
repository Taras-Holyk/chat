import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { LocalStorageService } from './services/local-storage.service';
import { Router } from '@angular/router';
import { catchError } from 'rxjs/operators';

@Injectable()
export class RequestInterceptor implements HttpInterceptor {
  constructor(public localStorageService: LocalStorageService,
              private router: Router) {}
  intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    if (this.localStorageService.get('userAuthToken')) {
      request = request.clone({
        setHeaders: {
          Authorization: `Bearer ${this.localStorageService.get('userAuthToken')}`
        }
      });
    }
    return next.handle(request).pipe(catchError((error, caught) => {
      if (error instanceof HttpErrorResponse) {
        if (error.status === 401) {
          this.router.navigate(['/login']);
        }
      }
      return of(error);
    }) as any);
  }
}
