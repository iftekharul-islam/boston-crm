<template>
  <div class="order-details__right col-md-6">
    Appraisal Details
    <div class="order-details-box bg-white">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Appraisal Details</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="list__group">
          <p class="mb-0 left-side">Appraisal Type</p>
          <span>:</span>
          <p class="right-side mb-0">John Doe</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Appraiser Name</p>
          <span>:</span>
          <p class="right-side mb-0">25 Jun 2022</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Client Order #</p>
          <span>:</span>
          <p class="right-side mb-0">25 Jun 2022</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Loan #</p>
          <span>:</span>
          <p class="right-side mb-0">1453 Dorchester Ave, Boston,
            Ma 02122</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Loan Type </p>
          <span>:</span>
          <p class="right-side mb-0">1453 Dorchester Ave, Boston,
            Ma 02122</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">FHA Case</p>
          <span>:</span>
          <p class="right-side mb-0">1453 Dorchester Ave, Boston,
            Ma 02122</p>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Appraisal Fee </p>
          <span>:</span>
          <p class="right-side mb-0">1453 Dorchester Ave, Boston,
            Ma 02122</p>
        </div>
      </div>
    </div>
    Client
    <div class="order-details-box bg-white">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Client</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="list mb-3">
          <div class="list__group mb-3">
            <p class="mb-0 left-side">AMC name</p>
            <span>:</span>
            <p class="right-side mb-0">EStreet Appraisal Management
              Company, LLC</p>
          </div>
          <a href="#" class="underline text-primary text-600">AMC requirements</a>
        </div>
        <div class="list__group">
          <p class="mb-0 left-side">Lender/ Bank name</p>
          <span>:</span>
          <p class="right-side mb-0">NEWREZ LLC</p>
        </div>
        <div class="list">
          <div class="list__group mb-3">
            <p class="mb-0 left-side">AMC name</p>
            <span>:</span>
            <p class="right-side mb-0">EStreet Appraisal Management
              Company, LLC</p>
          </div>
          <a href="#" class="underline text-primary text-600">AMC requirements</a>
        </div>
      </div>
    </div>
    Call log
    <div class="order-details-box bg-white">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Call log</p>
        <a href="" class="d-inline-flex edit add-call align-items-center fw-bold">Add call log</a>
      </div>
      <div class="box-body">
        <div class="col-log">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
              <tr>
                <th scope="col">SL</th>
                <th scope="col">Caller name</th>
                <th scope="col">Call date & time</th>
                <th scope="col">Message</th>
                <th scope="col"></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>1.</td>
                <td>Sandy Rock</td>
                <td>12.02.2022  3:45 pm</td>
                <td>I have called and left a message</td>
                <td><router-link to="/" class="message">
                  <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                </router-link></td>
              </tr>
              <tr>
                <td>1.</td>
                <td>Sandy Rock</td>
                <td>12.02.2022  3:45 pm</td>
                <td>I have called and left a message</td>
                <td><router-link to="/" class="message">
                  <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                </router-link></td>
              </tr>
              <tr>
                <td>1.</td>
                <td>Sandy Rock</td>
                <td>12.02.2022  3:45 pm</td>
                <td>I have called and left a message</td>
                <td><router-link to="/" class="message">
                  <span class="icon-messages2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></span>
                </router-link></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    Map
    <div class="order-details-box bg-white">
      <div class="box-header">
        <p class="fw-bold text-light-black fs-20 mb-0">Map</p>
        <a href="" class="d-inline-flex edit align-items-center fw-bold">Edit <span class="icon-edit ms-3"><span class="path1"></span><span class="path2"></span></span></a>
      </div>
      <div class="box-body">
        <div class="map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423286.2817730339!2d-118.69260188474334!3d34.02015975940636!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos%20Angeles%2C%20CA%2C%20USA!5e0!3m2!1sen!2sbd!4v1650253099882!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
  export default {
    data(){
      return{

      }
    }
  }
</script>
