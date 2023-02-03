<?php
$this->load->view('template/header');
$this->load->view('template/page_header');
// echo  '<div class="page-body-wrapper">';
$this->load->view('template/sidebar');
// echo '<div class="page-body">';
// echo '<div class="container-fluid">
//     <div class="page-title">
//       <div class="row">
//         <div class="col-6">
//           <h3>Default</h3>
//         </div>
//         <div class="col-6">
//           <ol class="breadcrumb">
//             <li class="breadcrumb-item">
//               <a href=""> <i data-feather="home"></i></a>
//             </li>
//             <li class="breadcrumb-item">' . $title . '</li>
//             <li class="breadcrumb-item active">Default</li>
//           </ol>
//         </div>
//       </div>
//     </div>
//   </div>
//   ';
// echo '<br>';
$this->load->view($page);
// echo  '</div>';
$this->load->view('template/footer');
