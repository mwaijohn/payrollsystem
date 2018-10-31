<form action="./manageemployee/register.php" method="POST">
          <br><br>
          <h2 class="bio">Bio Details</h2><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="fname">First name</label>
              <input type="text" class="form-control" placeholder="First name" id="fname" name="fname" required>
            </div>
            <div class="col col-sm-4">
              <label for="mname">Middle name</label>
              <input type="text" class="form-control" placeholder="middle name" id="mname" name="mname" required>
            </div>
          </div><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="lname">Last name</label>
              <input type="text" class="form-control" placeholder="Last name" id="lname" name="lname" required>
            </div>
            <div class="col col-sm-4">
              <label for="gender">gender</label>
              <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="gender">
                <option selected>Choose gender</option>
                <option value="male">male</option>
                <option value="female">female</option>
              </select>
            </div>

          </div><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="email">email</label>
              <input type="email" class="form-control" placeholder="email address" id="email" name="email" required>
            </div>
            <div class="col col-sm-4">
              <label for="contact">Phone</label>
              <input type="tel" class="form-control" placeholder="contact" id="contact" name="contact" required>
            </div>
          </div><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="dob">Date of Birth</label>
              <input type="date" class="form-control" placeholder="date of birth" id="dob" name="dob" required>
            </div>
            <div class="col col-sm-4">
              <label for="idno">Id number</label>
              <input type="tel" class="form-control" placeholder="contact" id="idno" name="idno" required>
            </div>
          </div>
          <br><br>
          <h2 class="bio">Working Information</h2><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="department">department</label>
              <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="department">
                <option selected>Choose department</option>
                <option value="male">sales</option>
                <option value="female">Manufacturing</option>
              </select>
            </div>
            <div class="col col-sm-4">
              <label for="etype">Employee type</label>
              <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref" name="etype" id="etype">
                <option selected>Choose employee type</option>
                <option value="casual">casual</option>
                <option value="permanent">permanent</option>
              </select>
            </div>
            <div class="col col-sm-4">
              <label for="salary">Basic Salary</label>
              <input type="number" class="form-control" placeholder="basic Salary" id="Salary" name="salary">
            </div>
          </div><br>
          <br><br>
          <h2 class="bio">Legal Information</h2><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="a/c">Account number</label>
              <input type="number" class="form-control" placeholder="Bank account number" id="a/c" name="a/c" required>
            </div>
            <div class="col col-sm-4">
              <label for="bname">Bank name</label>
              <input type="text" class="form-control" placeholder="Bank name" id="bname" name="bname" required>
            </div>
            <div class="col col-sm-4">
              <label for="branch">Bank Branch</label>
              <input type="text" class="form-control" placeholder="Bank branch" id="branch" name="branch">
            </div>
          </div><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="kra">KRA PIN</label>
              <input type="text" class="form-control" placeholder="KRA PIN" id="kra" name="kra">
            </div>
            <div class="col col-sm-4">
              <label for="nhif">NHIF number</label>
              <input type="text" class="form-control" placeholder="nhif number" id="nhif" name="nhif">
            </div>
            <div class="col col-sm-4">
              <label for="nssf">NSSF number</label>
              <input type="text" class="form-control" placeholder="nssf number" id="nssf" name="nssf">
            </div>
          </div><br>
          <h2 class="bio">Next of Kin</h2><br>
          <div class="form-row">
            <div class="col col-sm-4">
              <label for="kinname">Next of Kin</label>
              <input type="text" class="form-control" placeholder="Enter both names" id="kinname" name="kinname">
            </div>
            <div class="col col-sm-4">
              <label for="kincontact">Next of kin contact</label>
              <input type="text" class="form-control" placeholder="contact" id="kincontact" name="kincontact">
            </div>
            <div class="col col-sm-4">
              <label for="kinaddress">Next of kin address</label>
              <input type="text" class="form-control" placeholder="P.O.Box address" id="kinaddress" name="kinaddress">
            </div>
          </div><br>
          <button type="submit" class="btn btn-info reg">Register Employee</button>
        </form>