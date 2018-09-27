import {Component, OnDestroy, OnInit} from '@angular/core';
import {UserService} from '../../../services/user.service';
import {User} from '../../../models/user';
import {takeWhile} from 'rxjs/operators';

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss']
})
export class UsersListComponent implements OnInit, OnDestroy {
  users: User[];
  alive$ = true;
  constructor(private userService: UserService) { }

  ngOnInit() {
    this.userService.getUsersList(1, 10, '')
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.users = result.data;
      });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }
}
