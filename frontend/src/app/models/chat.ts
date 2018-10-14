import {Message} from './message';
import {User} from './user';

export interface Chat {
  id: string;
  user: User;
  last_message: Message;
}
