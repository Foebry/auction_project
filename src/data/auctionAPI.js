import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const auctionAPI = createApi({
    reducerPath: "auctionState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getAuctions: builder.query({
            query: ({ categories, page, page_count, sort, status }) => {
                const query =
                    (categories && categories !== "") ||
                    page ||
                    page_count ||
                    (sort && sort !== []) ||
                    status
                        ? "/auctions?"
                        : "/auctions";

                let params = [];

                if (categories) params = [...params, `cat_id=${categories}`];
                if (page) params = [...params, `page=${page}`];
                if (page_count)
                    params = [...params, `page_count=${page_count}`];
                if (sort?.length > 0)
                    params = [...params, `sort=${sort.join(",")}`];
                if (status !== undefined)
                    params = [...params, `status=${status}`];

                params = params.join("&");

                return `${query}${params}`;
            },
            providesTags: ["allAuctions"],
        }),
        getAuctionById: builder.query({
            query: (id) => `/auction/${id}`,
        }),
        getAuctionBiddingsById: builder.query({
            query: (id) => `/auction/${id}/biddings`,
        }),
        postAuction: builder.mutation({
            query: ({ auc_art_id, auc_expiration, auc_start }) => ({
                url: `/auctions`,
                method: "POST",
                body: {
                    auc_art_id,
                    auc_start,
                    auc_expiration,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allAuctions"],
        }),
        updateAuction: builder.mutation({
            query: ({ id, auc_expiration, auc_start, auc_art_id }) => ({
                url: `/auction/${id}`,
                method: "PATCH",
                body: {
                    auc_expiration,
                    auc_start,
                    auc_art_id,
                    csrf: localStorage.getItem("csrf"),
                },
                invalidatesTags: ["allAuctions"],
            }),
        }),
        updateAllAuctions: builder.mutation({
            query: ({ auc_expiration }) => ({
                url: "/auctions",
                method: "PATCH",
                body: {
                    auc_expiration,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allAuctions"],
        }),
    }),
});

export default auctionAPI;
export const {
    useGetAuctionsQuery,
    useGetAuctionByIdQuery,
    useGetAuctionBiddingsByIdQuery,
    usePostAuctionMutation,
    useUpdateAuctionMutation,
    useUpdateAllAuctionsMutation,
} = auctionAPI;
