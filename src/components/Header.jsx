import { Link } from "react-router-dom";

const Header = () => {
  return (
    <header className="header container">
      <div className="header__items container__medium">
        <h1 className="header__items__text">
          <span>OneClick</span> Pirate
        </h1>
        <div>
          <Link to={"#"}>Login</Link>
          <Link to={"#"}>register</Link>
        </div>
      </div>
    </header>
  );
};

export default Header;
