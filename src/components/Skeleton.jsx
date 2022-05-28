import { useContext } from "react";
import Header from "./Header";
import Footer from "./Footer";
import { AppContext } from "../context/AppContext";
import Modal from "./modals/Modal";

const Skeleton = ({ children }) => {
    const { modal, onClose } = useContext(AppContext);
    const isBlur = (e) => e.target.className == "blur" && onClose();

    return (
        <>
            <Header />
            <main className={modal ? "blur" : null} onClick={isBlur}>
                {children}
            </main>
            <Footer />
            <Modal />
        </>
    );
};

export default Skeleton;
