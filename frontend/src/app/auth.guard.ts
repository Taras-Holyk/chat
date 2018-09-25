import { Injectable } from '@angular/core';
import { CanActivate, Router, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import {LocalStorageService} from './services/local-storage.service';

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(private localStorageService: LocalStorageService,
              private router: Router) {}

  canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
    if (this.localStorageService.get('authUser')) {
      return true;
    } else {
      this.router.navigate(['/login']);
      return false;
    }
  }
}
