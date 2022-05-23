import { createContext, useState } from "react";
import axios from "axios";

export const AppContext = createContext();

const AppProvider = ({ children }) => {
    const [userId, setUserId] = useState();
    const [modal, setModal] = useState(null);
    const onClose = () => setModal(null);

    const logout = () => {
        (async () => {
            await axios("https://www.wdev2.be/fs_sander/api/logout", {
                method: "DELETE",
                withCredentials: true,
            });
            localStorage.removeItem("usr_name");
            // window.location.reload();
        })();
    };
    return (
        <AppContext.Provider
            value={{
                userId,
                setUserId,
                modal,
                setModal,
                onClose,
                logout,
            }}
        >
            {children}
        </AppContext.Provider>
    );
};

export default AppProvider;
