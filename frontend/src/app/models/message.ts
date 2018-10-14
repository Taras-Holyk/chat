import {User} from './user';

export interface Message {
  id: string;
  text: string;
  created_at: string;
  user: User;
}
