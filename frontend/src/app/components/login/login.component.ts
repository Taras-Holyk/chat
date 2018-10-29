import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {UserService} from '../../services/user.service';
import {LocalStorageService} from '../../services/local-storage.service';
import {Router} from '@angular/router';
import {BroadcastService} from '../../services/broadcast.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  invalidCredentials = false;
  constructor(private userService: UserService,
              private localStorageService: LocalStorageService,
              private router: Router,
              private broadcastService: BroadcastService) {
    this.loginForm = new FormGroup({
      'email': new FormControl('', [Validators.required, Validators.email]),
      'password': new FormControl('', Validators.required)
    });
  }

  ngOnInit() {
    this.localStorageService.remove('userAuthToken');
    this.localStorageService.remove('authUser');

    this.loginForm.valueChanges.subscribe(() => this.invalidCredentials = false);
  }

  submit() {
    if (this.loginForm.valid) {
      this.userService.login(this.loginForm.get('email').value, this.loginForm.get('password').value)
        .subscribe(response => {
          this.localStorageService.set('userAuthToken', response.meta.original.access_token);
          this.localStorageService.set('authUser', response.data);
          this.broadcastService.broadcast('log-in');
          this.router.navigate(['']);
        }, error => {
          this.invalidCredentials = true;
        });
    } else {
      console.log('Validation error');
    }
  }
}
