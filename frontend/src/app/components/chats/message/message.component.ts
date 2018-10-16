import {Component, Input, OnInit} from '@angular/core';
import {User} from '../../../models/user';
import {LocalStorageService} from '../../../services/local-storage.service';

@Component({
  selector: 'app-message',
  templateUrl: './message.component.html',
  styleUrls: ['./message.component.scss']
})
export class MessageComponent implements OnInit {
  @Input() message;
  authUser: User;
  constructor(private localStorageService: LocalStorageService) { }

  ngOnInit() {
    this.authUser = this.localStorageService.get('authUser');
    this.message.created_at = new Date(this.message.created_at);
  }

}
