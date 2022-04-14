import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
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
  public page_title: string = 'Identificate';
  public user: User;
  public status: String | undefined;
  public token: string = '';
  public identity: string = '';

  constructor(
    private _userService: UserService,
    private _router: Router,
    private _route: ActivatedRoute
  ) {
    this.page_title = 'Identificate';
    this.user = new User(1, '', '', 'ROLE_USER', '', '', '', '');
  }

  ngOnInit(): void {
    this.logout();
  }

  onSubmit(form: any) {
    this._userService.login(this.user).subscribe(
      (response) => {
        if (response.status == 'success') {
          this.token = response.token;
          //OBJETO USUARIO IDENTIFICADO
          this._userService.login(this.user, true).subscribe(
            (response) => {
              this.identity = response.data;
              //persistir dato
              localStorage.setItem('token', this.token);
              localStorage.setItem('identity', JSON.stringify(this.identity));
              this._router.navigate(['/']);
            },
            (error) => {
              console.log(error);
            }
          );
          //form.reset();
        } else {
          console.log(11);
          this.status = 'error';
        }
      },
      (error) => {
        this.status = 'error';
        console.log(error);
      }
    );
  }

  logout() {
    this._route.params.subscribe((params) => {
      let sure = +params['sure'];
      if (sure == 1) {
        localStorage.removeItem('identity');
        localStorage.removeItem('token');
        this.identity = '';
        this.token = '';
        this._router.navigate(['/inicio']);
      }
    });
  }
}
