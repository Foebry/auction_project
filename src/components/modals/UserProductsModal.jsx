import BaseModal from "./baseModal";

const UserProductblury__modal = () => {
    return (
        <BaseModal>
            <div className="modal__userTitle">
                <h2>My Biddings</h2>
            </div>
            <div className="modal__userHistory">
                <p className="modal__userHistory__text">Articles</p>
                <div className="modal__userHistory__highest"></div>
            </div>
        </BaseModal>
    );
};

export default UserProductblury__modal;
