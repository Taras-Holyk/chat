import {Component, Input, OnDestroy, OnInit} from '@angular/core';
import {User} from '../../../models/user';
import {ChatsService} from '../../../services/chats.service';
import {takeWhile} from 'rxjs/operators';
import {Router} from '@angular/router';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit, OnDestroy {
  @Input() user: User;
  alive$ = true;
  constructor(private chatsService: ChatsService,
              private router: Router) { }

  ngOnInit() {
  }

  ngOnDestroy() {
    this.alive$ = false;
  }

  openChat() {
    this.chatsService.getChat(this.user.id)
      .pipe(takeWhile(() => this.alive$))
      .subscribe(result => {
        this.router.navigate(['chats', result.data._id]);
      });
  }
}
