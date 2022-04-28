const Footer = () => {
    let year = new Date().getFullYear();

    return (
        <footer className="footer container">
            <div className="footer__items container__medium">
                <p className="footer__items__text">© {year}</p>
                <div className="footer__items__people">
                    <p className="footer__items__text">Sander Fabry</p>
                    <p className="footer__items__text">Tim Vercammen</p>
                    <p className="footer__items__text">Michiel Peeters</p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
