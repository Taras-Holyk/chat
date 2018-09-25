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
  users: User[];
  totalPages: number;
  links: any = [];
  page = 1;
  limit = 10;
  searchKeyword = '';
  alive$ = true;
  searchForm: FormGroup;
  constructor(private userService: UserService,
              private activatedRoute: ActivatedRoute,
              private formBuilder: FormBuilder,
              private router: Router) { }

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
    if (params['page']) {
      this.page = params['page'];
    }
    if (params['limit']) {
      this.limit = params['limit'];
    }
    if (params['search']) {
      this.searchKeyword = params['search'];
    }
  }

  getPagination() {
    this.links = [];
    for (let i = 1; i <= this.totalPages; i++) {
      const link = {'page': i, 'limit': this.limit};
      if (this.searchKeyword) {
        link['search'] = this.searchKeyword;
      }
      this.links.push(link);
    }
  }

  getUsers(search: string) {
    this.userService.getUsersList(this.page, this.limit, search)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.users = result.data;
        this.totalPages = result.meta.last_page;
        this.getPagination();
      });
  }

  search() {
    this.searchKeyword = this.searchForm.get('keyword').value;
    if (this.searchKeyword) {
      this.router.navigate(['/users'], {'queryParams': {'search': this.searchKeyword}});
    } else {
      this.router.navigate(['/users']);
    }
  }
}
