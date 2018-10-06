import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {passwordConfirmed} from '../../validators/password-confirmed';
import {UserService} from '../../services/user.service';

@Component({
  selector: 'app-registration',
  templateUrl: './registration.component.html',
  styleUrls: ['./registration.component.scss']
})
export class RegistrationComponent implements OnInit {
  registrationForm: FormGroup;
  message = '';
  errors: any;
  constructor(private formBuilder: FormBuilder,
              private userService: UserService) {
    this.registrationForm = this.formBuilder.group({
      'name': ['', [Validators.required]],
      'email': ['', [Validators.required, Validators.email]],
      'password': ['', [Validators.required, Validators.minLength(8)]],
      'password_confirmation': ['', [Validators.required, passwordConfirmed(), Validators.minLength(8)]]
    });
  }

  ngOnInit() {
  }

  submit() {
    if (this.registrationForm.invalid) {
      console.log('Validation error');
      return;
    }

    this.userService.register(this.registrationForm.value)
      .subscribe(response => {
        this.message = 'Successfully registered';
      }, error => console.log(error));
  }
}
