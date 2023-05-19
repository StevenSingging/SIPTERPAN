<div class="card card-primary card-outline card-outline-tabs">
                                    <div class="card-header p-0 border-bottom-0">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item ">
                                                <a class="nav-link active " id="custom-tabs-one-sproject-tab" data-toggle="pill" href="#custom-tabs-one-sproject" role="tab" aria-controls="custom-tabs-one-sproject" aria-selected="true">Selected Project</a>
                                            </li>
                                            <li class="nav-item ">
                                                <a class="nav-link" id="omilestone-tab" data-toggle="pill" href="#omilestone" role="tab" aria-controls="omilestone" aria-selected="false">Other Milestone</a>
                                            </li>
                                        </ul>
                                    </div>
 
                                        <div class="tab-pane fade show active" id="custom-tabs-one-sproject" role="tabpanel" aria-labelledby="custom-tabs-one-sproject-tab">
                                            @foreach($prjk as $prj)
                                            <div class="form-group">
                                                <label for="inputName">Project Name</label>
                                                <input type="text" name="nama" class="form-control" value="{{$prj->nama}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputDescription">Description</label>
                                                <textarea class="form-control" rows="4" disabled>{{$prj->deskripsi}}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName">Start Date</label>
                                                <input type="date" class="form-control " value="{{$prj->mulai}}" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName">End Date</label>
                                                <input type="date" class="form-control" value="{{$prj->jatuh_tempo}}" disabled>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="tab-pane fade" id="omilestone" role="tabpanel" aria-labelledby="omilestone-tab">
                                        sdasd
                                        </div>
                                    
                                </div>