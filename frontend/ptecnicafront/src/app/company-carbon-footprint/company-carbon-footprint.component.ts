import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { API_CONFIG } from '../app.config';
interface Companyco2Interface {
  total: number;
}

@Component({
  selector: 'app-company-carbon-footprint',
  standalone: true,
  imports: [CommonModule, HttpClientModule],
  templateUrl: './company-carbon-footprint.component.html',
  styleUrl: './company-carbon-footprint.component.css'
})
export class CompanyCarbonFootprintComponent {
  ammount: Companyco2Interface = { total: 0 };
  client = inject(HttpClient);
  fetchData() {
    this.client.get(API_CONFIG.api_url + "company-carbon-footprint").subscribe((data: any) => {
      console.log(data)
      this.ammount = data;
    }
    )
  }

  ngOnInit(): void {
    this.fetchData();
  }

}
