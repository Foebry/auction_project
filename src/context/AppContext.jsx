import { createContext, useState } from "react";
import { useLogoutMutation } from "../data/authenticationAPI";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const [logout] = useLogoutMutation();
    const [activeUser, setActiveUser] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);
    const handleLogout = async () => {
        const { error } = await logout({});
        if (!error) {
            console.log("ok");
            localStorage.clear();
            window.location.reload();
        }
    };

    return (
        <AppContext.Provider
            value={{
                activeUser,
                setActiveUser,
                modal,
                setModal,
                onClose,
                handleLogout,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
