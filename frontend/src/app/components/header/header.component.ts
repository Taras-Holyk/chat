import {Component, OnDestroy, OnInit} from '@angular/core';
import {UserService} from '../../services/user.service';
import {User} from '../../models/user';
import {LocalStorageService} from '../../services/local-storage.service';
import {takeWhile} from 'rxjs/operators';
import {Router} from '@angular/router';
import {BroadcastService} from '../../services/broadcast.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit, OnDestroy {
  user: User;
  alive$ = true;
  isVisible = true;
  constructor(private usersService: UserService,
              private localStorageService: LocalStorageService,
              private router: Router,
              private broadcastService: BroadcastService) { }

  ngOnInit() {
    if (!this.localStorageService.get('authUser')) {
      this.isVisible = false;
      return;
    }
    this.usersService.getUser(this.localStorageService.get('authUser').id)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => this.user = result.data);

    this.broadcastService.subscribe('log-in', () => {
      setTimeout(() => this.isVisible = true, 100);
    });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  logout() {
    this.usersService.logout()
      .pipe(takeWhile(() => this.alive$))
      .subscribe(() => {
        this.localStorageService.remove('userAuthToken');
        this.localStorageService.remove('authUser');
        this.isVisible = false;
        this.router.navigate(['/login']);
      });
  }
}
