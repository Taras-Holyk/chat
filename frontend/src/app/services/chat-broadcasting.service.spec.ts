import { TestBed } from '@angular/core/testing';

import { ChatBroadcastingService } from './chat-broadcasting.service';

describe('ChatBroadcastingService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: ChatBroadcastingService = TestBed.get(ChatBroadcastingService);
    expect(service).toBeTruthy();
  });
});
