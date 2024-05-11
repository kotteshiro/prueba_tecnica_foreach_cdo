import { Component } from '@angular/core';
import { RouterModule, RouterOutlet } from '@angular/router';
import {MatIconModule} from '@angular/material/icon';
import {MatButtonModule} from '@angular/material/button';
import {MatToolbarModule} from '@angular/material/toolbar';
import { API_CONFIG } from './app.config';
@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterModule,MatToolbarModule, MatButtonModule, MatIconModule],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  api_url = API_CONFIG.api_url;
}
