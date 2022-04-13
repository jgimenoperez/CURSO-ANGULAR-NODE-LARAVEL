import { Component, OnInit } from '@angular/core';
import { User } from 'src/app/models/user';
//importar servicio
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [UserService],
})
export class LoginComponent implements OnInit {

  public page_title:string = "Identificate";
  public user: User;
  public status: String | undefined;
  public token:string | undefined;
  public identity: string | undefined;


  constructor(
    private _userService: UserService
  ) { 
    this.page_title = "Identificate";
    this.user = new User(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit(): void {
    console.log(1)
  }

  onSubmit(form:any){
    this._userService.login(this.user).subscribe(
      (response) => {
        if (response.status == 'success') {
          this.token = response;
          console.log(response)
         //form.reset();
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
