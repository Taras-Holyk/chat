import { Component, OnInit } from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {UserService} from '../../services/user.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  constructor(private userService: UserService) {
    this.loginForm = new FormGroup({
      'email': new FormControl('', [Validators.required, Validators.email]),
      'password': new FormControl('', Validators.required)
    });
  }

  ngOnInit() {
  }

  submit() {
    if (this.loginForm.valid) {
      this.userService.login(this.loginForm.get('email').value, this.loginForm.get('password').value)
        .subscribe(response => console.log(response));
    } else {
      console.log('Validation error');
    }
  }
}
