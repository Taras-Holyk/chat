import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {UserService} from '../../services/user.service';
import {LocalStorageService} from '../../services/local-storage.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  constructor(private userService: UserService,
              private localStorageService: LocalStorageService) {
    this.loginForm = new FormGroup({
      'email': new FormControl('', [Validators.required, Validators.email]),
      'password': new FormControl('', Validators.required)
    });
  }

  ngOnInit() {
    this.localStorageService.remove('userAuthToken');
    this.localStorageService.remove('authUser');
  }

  submit() {
    if (this.loginForm.valid) {
      this.userService.login(this.loginForm.get('email').value, this.loginForm.get('password').value)
        .subscribe(response => {
          this.localStorageService.set('userAuthToken', response.meta.original.access_token);
          this.localStorageService.set('authUser', response.data);
        });
    } else {
      console.log('Validation error');
    }
  }
}
