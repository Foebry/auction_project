import { Link } from "react-router-dom";
import { useState } from "react";

const Header = () => {
  const [loggedIn, setLoggedIn] = useState(true);

  return (
    <header className="header container">
      <div className="header__items container__medium">
        <h1 className="header__items__text">
          <span>OneClick</span> Pirate
        </h1>
        <div className="header__items__links">
          {!loggedIn && (
            <Link className="link" to={"#"}>
              Login
            </Link>
          )}
          {!loggedIn && (
            <Link className="link" to={"#"}>
              Register
            </Link>
          )}
          {loggedIn && (
            <p>
              Welcome <span>NAME</span>
            </p>
          )}
          {loggedIn && (
            <Link className="link" to={"#"}>
              My Products
            </Link>
          )}
          {loggedIn && (
            <Link className="link" to={"#"}>
              Logout
            </Link>
          )}
        </div>
      </div>
    </header>
  );
};

export default Header;
