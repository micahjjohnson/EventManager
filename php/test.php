<?php include './master/header.php';?>
<p> Test page using PHP header and footer imports.</p>


<div class="table1">
<div class="card">
  <h5 class="card-header">Table</h5>
  <div class="card-body">
    <table class="table table-striped table-hover">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
        </tr>
    </tbody>
    </table>
</div>
</div>
</div>
<br/>

<div class="card">
  <h5 class="card-header bg-primary text-white">Small Table</h5>
  <div class="card-body">
    <table class="table table-sm">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
        </tr>
        <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
        </tr>
        <tr>
        <th scope="row">3</th>
        <td colspan="2">Larry the Bird</td>
        <td>@twitter</td>
        </tr>
    </tbody>
    </table>
</div>
</div>
<br/>

<div class="card">
  <h5 class="card-header">New Event</h5>
  <div class="card-body">
        <form>
        <div class="form-row">
            <div class="form-group col-md-8">
            <label for="inputEmail4">Event Title</label>
            <input type="text" class="form-control" id="inputEmail4" placeholder="Enter title here...">
            </div>
            <div class="form-group col-md-4">
            <label for="inputPassword4">Date</label>
            <input type="date" class="form-control" id="inputPassword4">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label for="inputCity">City</label>
            <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="form-group col-md-4">
            <label for="inputState">State</label>
            <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
            </select>
            </div>
            <div class="form-group col-md-2">
            <label for="inputZip">Zip</label>
            <input type="text" class="form-control" id="inputZip">
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
                Some checkbox
            </label>
            </div>
        </div>
        <button type="cancel" class="btn ">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
        </form>

  </div>
</div>

<br/><br/><br/>
<?php include './master/footer.php';?>