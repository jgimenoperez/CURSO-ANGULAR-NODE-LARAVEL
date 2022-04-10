import { Component, OnInit } from '@angular/core';
//importar user
import { User } from '../../models/user';
//importar servicio
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserService],
})
export class RegisterComponent implements OnInit {
  public page_title: string = 'Registrate';
  public user: User;
  public status: String | undefined;

  constructor(private _userService: UserService) {
    this.page_title = 'Registrate';
    this.user = new User(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit(): void {
    // console.log("RegisterComponent");
  }

  onSubmit(form: any) {
    this._userService.register(this.user).subscribe(
      (response) => {
        if (response.status == 'success') {
          this.status = response.status;
          form.reset();
        } else {
          this.status = 'error';
        }
      },
      (error) => {
        this.status = 'error';
        console.log(error);
      }
    );
  }
}
