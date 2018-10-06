import { ChatsRoutingModule } from './chats-routing.module';

describe('ChatsRoutingModule', () => {
  let chatsRoutingModule: ChatsRoutingModule;

  beforeEach(() => {
    chatsRoutingModule = new ChatsRoutingModule();
  });

  it('should create an instance', () => {
    expect(chatsRoutingModule).toBeTruthy();
  });
});
