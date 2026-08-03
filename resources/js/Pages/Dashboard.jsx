import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard(props) {
    const { auth } = usePage().props;

    const {
        totalRooms = 0,
        totalBookings = 0,
        pending = 0,
        approved = 0,
        rejected = 0,
        completed = 0,
        latestBookings = [],
    } = props;

    const hasRole = (role) => {
        return auth.user.roles?.some((item) => item.name === role);
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="fs-4 fw-semibold">Dashboard</h2>}
        >
            <Head title="Dashboard" />

            <div className="container py-4">
                {/* ===================== */}
                {/* Statistik */}
                {/* ===================== */}

                <div className="row g-3 mb-4">
                    {hasRole("Admin") && (
                        <div className="col-md-3">
                            <div className="card border-primary shadow-sm">
                                <div className="card-body text-center">
                                    <h6>Total Ruangan</h6>
                                    <h2>{totalRooms}</h2>
                                </div>
                            </div>
                        </div>
                    )}

                    <div className="col-md-3">
                        <div className="card border-dark shadow-sm">
                            <div className="card-body text-center">
                                <h6>Total Pengajuan</h6>
                                <h2>{totalBookings}</h2>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-3">
                        <div className="card border-warning shadow-sm">
                            <div className="card-body text-center">
                                <h6>Menunggu</h6>
                                <h2 className="text-warning">{pending}</h2>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-3">
                        <div className="card border-success shadow-sm">
                            <div className="card-body text-center">
                                <h6>Disetujui</h6>
                                <h2 className="text-success">{approved}</h2>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-3">
                        <div className="card border-danger shadow-sm">
                            <div className="card-body text-center">
                                <h6>Ditolak</h6>
                                <h2 className="text-danger">{rejected}</h2>
                            </div>
                        </div>
                    </div>

                    <div className="col-md-3">
                        <div className="card border-info shadow-sm">
                            <div className="card-body text-center">
                                <h6>Selesai</h6>
                                <h2 className="text-info">{completed}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                {/* ===================== */}
                {/* Riwayat Pengajuan */}
                {/* ===================== */}

                <div className="card shadow-sm">
                    <div className="card-header bg-white">
                        <h5 className="mb-0">Pengajuan Terbaru</h5>
                    </div>

                    <div className="card-body p-0">
                        <table className="table table-striped table-hover mb-0">
                            <thead className="table-light">
                                <tr>
                                    <th>No</th>

                                    <th>Dosen</th>

                                    <th>Ruangan</th>

                                    <th>Tanggal</th>

                                    <th>Jam</th>

                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                {latestBookings.length === 0 ? (
                                    <tr>
                                        <td
                                            colSpan="6"
                                            className="text-center py-4"
                                        >
                                            Belum ada data.
                                        </td>
                                    </tr>
                                ) : (
                                    latestBookings.map((booking, index) => (
                                        <tr key={booking.id}>
                                            <td>{index + 1}</td>

                                            <td>{booking.user?.name ?? "-"}</td>

                                            <td>{booking.room?.name ?? "-"}</td>

                                            <td>{booking.booking_date}</td>

                                            <td>
                                                {booking.start_time} -{" "}
                                                {booking.end_time}
                                            </td>

                                            <td>
                                                {booking.status ===
                                                    "Menunggu" && (
                                                    <span className="badge bg-warning">
                                                        Menunggu
                                                    </span>
                                                )}

                                                {booking.status ===
                                                    "Disetujui" && (
                                                    <span className="badge bg-success">
                                                        Disetujui
                                                    </span>
                                                )}

                                                {booking.status ===
                                                    "Ditolak" && (
                                                    <span className="badge bg-danger">
                                                        Ditolak
                                                    </span>
                                                )}

                                                {booking.status ===
                                                    "Selesai" && (
                                                    <span className="badge bg-primary">
                                                        Selesai
                                                    </span>
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

// import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
// import { Head } from "@inertiajs/react";

// export default function Dashboard() {
//     return (
//         <AuthenticatedLayout
//             header={
//                 <h2 className="text-xl font-semibold leading-tight text-gray-800">
//                     Dashboard
//                 </h2>
//             }
//         >
//             <Head title="Dashboard" />

//             <div className="py-12">
//                 <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
//                     <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
//                         <div className="p-6 text-gray-900">
//                             You're logged in!
//                             <div className="mt-4">
//                                 <h2>Selamat Datang</h2>

//                                 <p>{auth.user.name}</p>

//                                 <p>{auth.user.email}</p>
//                             </div>
//                         </div>
//                     </div>
//                 </div>
//             </div>
//         </AuthenticatedLayout>
//     );
// }
