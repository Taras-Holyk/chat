import {Component, OnDestroy, OnInit} from '@angular/core';
import {UserService} from '../../../services/user.service';
import {User} from '../../../models/user';
import {takeWhile} from 'rxjs/operators';
import {ActivatedRoute, Router} from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-users-list',
  templateUrl: './users-list.component.html',
  styleUrls: ['./users-list.component.scss']
})
export class UsersListComponent implements OnInit, OnDestroy {
  users: User[] = [];
  page = 1;
  limit = 10;
  searchKeyword = '';
  alive$ = true;
  searchForm: FormGroup;
  isEnabledShowMore = false;
  constructor(private userService: UserService,
              private activatedRoute: ActivatedRoute,
              private formBuilder: FormBuilder) { }

  ngOnInit() {
    this.searchForm = this.formBuilder.group({
      'keyword': ['', [Validators.required]]
    });

    this.activatedRoute.queryParams
      .pipe(takeWhile(() => this.alive$))
      .subscribe(params => {
        this.setParams(params);
        this.getUsers(this.searchKeyword);
      });
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  setParams(params) {
    if (params['search']) {
      this.searchKeyword = params['search'];
    }
  }

  getUsers(search: string) {
    this.userService.getUsersList(this.page, this.limit, search)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.users = [...this.users, ...result.data];

        if (this.users.length >= result.meta.total) {
          this.isEnabledShowMore = false;
        } else {
          this.isEnabledShowMore = true;
        }
      });
  }

  search() {
    this.users = [];
    this.page = 1;
    this.searchKeyword = this.searchForm.get('keyword').value;
    this.getUsers(this.searchKeyword);
  }

  showMore() {
    this.page++;
    this.getUsers(this.searchKeyword);
  }
}
