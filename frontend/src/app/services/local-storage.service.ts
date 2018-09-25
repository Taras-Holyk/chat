import { Injectable, Inject } from '@angular/core';
import {LOCAL_STORAGE, StorageService} from 'angular-webstorage-service';

@Injectable({
  providedIn: 'root'
})
export class LocalStorageService {
  constructor(@Inject(LOCAL_STORAGE) private storage: StorageService) { }

  set(key, value) {
    return this.storage.set(key, value);
  }
  get(key) {
    return this.storage.get(key);
  }
  remove(key) {
    return this.storage.remove(key);
  }
}
