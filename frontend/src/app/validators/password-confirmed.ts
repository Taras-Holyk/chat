import { ValidatorFn, AbstractControl } from '@angular/forms';

export function passwordConfirmed(): ValidatorFn {
  return (control: AbstractControl): {[key: string]: any} => {
    const form = control.root;
    const password = form.get('password') ? form.get('password').value : null;
    const passwordConfirmation = form.get('password_confirmation') ? form.get('password_confirmation').value : null;
    return password === passwordConfirmation ? null : { notSame: true };
  };
}
