import React, { useMemo, useState } from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import { useGetUsersQuery, useDeleteUserMutation } from "../../data/userAPI";
import ConfirmationModal from "../../components/modals/messageModals/ConfirmationModal";

const Users = () => {
    const [nameFilter, setNameFilter] = useState("");
    const [confirm, setConfirm] = useState(false);
    const [userToDelete, setUserToDelete] = useState();
    const [deleteUser] = useDeleteUserMutation();

    const { data, isError, isLoading } = useGetUsersQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const confirmDelete = (e) => {
        const id = e.target.dataset.id;
        const user = data?.filter((el) => el.id == id)[0].name;
    };

    const handleDelete = async () => {
        const { data, error } = await deleteUser(userToDelete);

        if (error) {
            console.log(error);
        } else if (data) {
            setConfirm(false);
            setUserToDelete(undefined);
        }
    };

    const memoData = useMemo(() => {
        return data
            ?.filter((el) =>
                el.name.toLowerCase().includes(nameFilter.toLowerCase())
            )
            .map(({ id, name, email, isAdmin }) => {
                return (
                    <li className="list__user" key={id}>
                        <p>{name}</p>
                        <p className="list__user__email">{email}</p>
                        <p className="list__user__role">
                            {isAdmin ? "Admin" : "User"}
                        </p>
                        <div className="list__buttons">
                            <button
                                className="list__buttons__button"
                                onClick={confirmDelete}
                            >
                                <MdModeEdit />
                            </button>
                            <button
                                className="list__buttons__button"
                                onClick={confirmDelete}
                                data-id={id}
                            >
                                <MdDelete className="icon" />
                            </button>
                        </div>
                    </li>
                );
            });
    }, [data, nameFilter]);

    return (
        <>
            <ul className="list">
                <li className="list__user">
                    <p>Naam</p>
                    <p className="list__user__email">Email</p>
                    <p>Role</p>
                    <input
                        type="text"
                        placeholder="User Name"
                        value={nameFilter}
                        className="listFilter"
                        onChange={(e) => setNameFilter(e.target.value)}
                    />
                </li>
                {isError && <p>error..</p>}
                {isLoading && <p>loading..</p>}
                {memoData}
            </ul>
            <ConfirmationModal
                isShown={confirm}
                primaryAction="Delete"
                secondaryAction="Cancel"
                message={"Delete User"}
                onPrimaryAction={handleDelete}
                onSecondaryAction={() => setConfirm(false)}
                onCancel={() => setConfirm(false)}
            >
                <p>
                    You are about to delete user{" "}
                    {data?.filter((el) => el.id === userToDelete)[0]?.name}{" "}
                </p>
            </ConfirmationModal>
        </>
    );
};

export default Users;
