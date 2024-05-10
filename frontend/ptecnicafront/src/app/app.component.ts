import { Component } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import {MatIconModule} from '@angular/material/icon';
import {MatButtonModule} from '@angular/material/button';
import {MatToolbarModule} from '@angular/material/toolbar';
@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterModule,MatToolbarModule, MatButtonModule, MatIconModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  logMovies = async function() {
    const response = await fetch("http://localhost/");
    const movies = await response.json();
    console.log(movies);
  }
}
