<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body>        
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title d-inline font-weight-bold text_darkblue">About Me</h4>
                                <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_info"><i class="fas fa-edit"></i> Edit </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Speciality </span> The Pianist
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-calendar-alt"></i> Professional</span> Since 2004
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> New York 
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Languages</span> English, French
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-2"> 
                                            <i class="fas fa-graduation-cap"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Education </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_education"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <ol class="about_list">
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Associate of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                        <span class="trash_info_btn">
                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal_delete"> <i class="fa fa-trash"></i> </a>
                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal_edit_education"> <i class="fa fa-edit"></i> </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p>Full Sail University</p> 
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Bachelor of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                        <span class="trash_info_btn">
                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal_delete"> <i class="fa fa-trash"></i> </a>
                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal_edit_education"> <i class="fa fa-edit"></i> </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p>The Art Institutes</p> 
                                                </div>
                                            </li>
                                        </ol>
                                        <hr/> 
                                        <div class="mb-2"> 
                                            <i class="fas fa-briefcase"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Experience </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_job_experience"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <ol class="about_list">
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                        <span class="trash_info_btn">
                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal_delete"> <i class="fa fa-trash"></i> </a>
                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal_edit_job_experience"> <i class="fa fa-edit"></i> </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p>Full Sail University</p> 
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Bachelor of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                        <span class="trash_info_btn">
                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal_delete"> <i class="fa fa-trash"></i> </a>
                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal_edit_job_experience"> <i class="fa fa-edit"></i> </a>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p>The Art Institutes</p> 
                                                </div>
                                            </li>
                                        </ol>
                                        <hr/>
                                        <div class="mb-2"> 
                                            <i class="fas fa-user-shield"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> affiliations </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_affiliation"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <div class="mb-4">
                                            <p>Performing Rights Organization (P.R.O.) USA</p>
                                        </div>
                                        <div class="mb-4">
                                            <span class="d-block font-weight-bold text-uppercase mb-1"> <i class="fas fa-users"></i> Groups</span>
                                            <p>The Clash, MozART Group, The Birthday Party</p>
                                        </div>
                                        <div class="mb-2"> 
                                            <span class="font-weight-bold text-uppercase mb-2"> Description </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_description"><i class="fas fa-edit"></i> Edit </a>
                                        </div>
                                        <p>Colin Nicholson is a fine classical pianist, music tutor and piano technician. Born in Rothbury and bred in Morpeth, Northumberland, Colin moved to Yorkshire in 1989. After over 25 years, Colin has now returned to Northumberland for good to fulfil his career, in and about the areas of Morpeth, Amble, Warkworth, Alnwick and visit many more North Eastern areas and coastal regions.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>

        <!-- Edit Info modal Start -->
        <div class="modal fade" id="modal_edit_info" tabindex="-1" role="dialog" aria-labelledby="modal_edit_info" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Info </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Speciality</label>
                                        <select class="form-control">
                                            <option>The Pianist</option>
                                            <option>The Pianist</option>
                                            <option>The Pianist</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Since</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Location</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Language</label>
                                        <select class="form-control">
                                            <option>English</option>
                                            <option>Arabic</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Info modal -->
        <!-- Edit Info modal END -->                

        <!-- Edit Description modal Start -->
        <div class="modal fade" id="modal_edit_description" tabindex="-1" role="dialog" aria-labelledby="modal_edit_description" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Description </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control h_140"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!-- Edit Description modal END -->

        <!-- Add Affiliation modal Start -->
        <div class="modal fade" id="modal_add_affiliation" tabindex="-1" role="dialog" aria-labelledby="modal_add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Affiliation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Union</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Add Affiliation modal -->
        <!-- Add Affiliation modal END -->

        <!-- Add Education Start modal -->
        <div class="modal fade" id="modal_add_education" tabindex="-1" role="dialog" aria-labelledby="modal_add_education" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Education</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">College/University</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Degree Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Add Education modal -->
        <!-- Add Education Start modal END --> 
        
        <!-- Edit Education Start modal -->
        <div class="modal fade" id="modal_edit_education" tabindex="-1" role="dialog" aria-labelledby="modal_edit_education" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Education</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">College/University</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Degree Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Add Education modal -->
        <!-- Add Education Start modal END --> 

        <!-- Job Experience Start modal -->
        <div class="modal fade" id="modal_add_job_experience" tabindex="-1" role="dialog" aria-labelledby="modal_add_job_experience" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Job Experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Company</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Job Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Experience modal -->
        <!-- Job Experience modal END -->         
        
        <!-- Edit Job Experience Start modal -->
        <div class="modal fade" id="modal_edit_job_experience" tabindex="-1" role="dialog" aria-labelledby="modal_edit_job_experience" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Job Experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Company</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Job Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Job Experience modal -->
        <!-- Edit Job Experience modal END -->

        <!-- Delete Model-->
        <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div>
            </div>
        </div> <!-- modal -->
        <!-- Delete modal END -->   
    </body>
</html>