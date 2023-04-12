<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?>Login<?= $this->endSection() ?>

<?= $this->section("content") ?>

    <h1>Login</h1>

<?= form_open("/login/create") ?>

    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= old('email') ?>">
    </div>

    <div>
        <label for="name">Password</label>
        <input type="password" name="password">
    </div>


    <button>Log in</button>
    <a href="<?= site_url("/")?>">Cancel</a>

    </form>

<?= $this->endSection() ?>